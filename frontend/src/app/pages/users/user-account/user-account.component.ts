import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { forkJoin, Observable, of } from 'rxjs';
import { catchError, finalize, tap } from 'rxjs/operators';
import { tooWeakValidator } from '../../../validators/too-weak-validator';
import { User } from '../../../models/entity/user.class';
import { AuthenticationService } from '../../../services/authentication.service';
import { UserService } from '../../../services/user.service';
import { NotificationService } from '../../../services/notification.service';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';

@Component({
  selector: 'app-user-account',
  templateUrl: './user-account.component.html',
  styleUrls: ['./user-account.component.scss'],
})
export class UserAccountComponent implements OnInit {
  public isLoading = false;
  protected user: User;
  public form = this.formBuilder.nonNullable.group(
    {
      email: ['', Validators.compose([Validators.required, Validators.email])],
      firstName: ['', Validators.required],
      lastName: ['', Validators.required],
      password: this.formBuilder.nonNullable.group(
        {
          oldPassword: [''],
          newPassword: ['', Validators.compose([Validators.minLength(8), tooWeakValidator])],
          newPasswordConfirmation: [''],
        },
        {
          validators: [
            group => group.value.newPassword === group.value.newPasswordConfirmation ? null : { notSame: true },
          ],
        },
      ),
    },
  );

  constructor(
    protected readonly formBuilder: FormBuilder,
    protected readonly authenticationService: AuthenticationService,
    protected readonly userService: UserService,
    protected readonly notification: NotificationService,
  ) { }

  ngOnInit() {
    this
      .authenticationService
      .user$
      .subscribe(user => {
        this.user = user;
        this.form.patchValue(user);
      })
    ;
  }

  public onSubmit(): void {
    const formRawValue = this.form.getRawValue();

    this.isLoading = true;

    const updates: Observable<User>[] = [];
    updates.push(
      this
        .userService
        .update(Object.assign(
          new User(),
          {id: this.user.id},
          {
            email: formRawValue.email,
            firstName: formRawValue.firstName,
            lastName: formRawValue.lastName,
          },
        ))
        .pipe(
          tap(user => this.authenticationService.updateCurrentUser(user)),
        ),
    );

    if (formRawValue.password.newPassword) {
      this.form.controls.password.setErrors({ wrongOldPassword: false });

      updates.push(
        this
          .userService
          .updatePassword(
            this.user,
            {
              oldPassword: formRawValue.password.oldPassword,
              newPassword: formRawValue.password.newPassword,
            },
          )
          .pipe(
            catchError(error => {
              this.form.controls.password.setErrors({ wrongOldPassword: true });

              throw of(error);
            }),
          )
        ,
      );
    }

    forkJoin(updates)
      .pipe(
        finalize(() => this.isLoading = false),
        tap(() => this.notification.success(_('UserAccount.Updated'), _('Action.Ok'), { verticalPosition: 'top' })),
      )
      .subscribe(() => this.form.controls.password.reset())
    ;
  }
}
