import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { forkJoin, Observable, of } from 'rxjs';
import { catchError, finalize, tap } from 'rxjs/operators';
import { tooWeakValidator } from '@validators/too-weak-validator';
import { Property } from '@entity/property.class';
import { AuthenticationService } from '@services/authentication.service';
import { PropertyService } from '@services/property.service';
import { NotificationService } from '@services/notification.service';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';

@Component({
  selector: 'app-property-account',
  templateUrl: './property-account.component.html',
  styleUrls: ['./property-account.component.scss'],
})
export class PropertyAccountComponent implements OnInit {
  public isLoading = false;
  protected property: Property;
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
    protected readonly propertyService: PropertyService,
    protected readonly notification: NotificationService,
  ) { }

  ngOnInit() {
    this
      .authenticationService
      .property$
      .subscribe(property => {
        this.property = property;
        this.form.patchValue(property);
      })
    ;
  }

  public onSubmit(): void {
    const formRawValue = this.form.getRawValue();

    this.isLoading = true;

    const updates: Observable<Property>[] = [];
    updates.push(
      this
        .propertyService
        .update(Object.assign(
          new Property(),
          {id: this.property.id},
          {
            email: formRawValue.email,
            firstName: formRawValue.firstName,
            lastName: formRawValue.lastName,
          },
        ))
        .pipe(
          tap(property => this.authenticationService.updateCurrentProperty(property)),
        ),
    );

    if (formRawValue.password.newPassword) {
      this.form.controls.password.setErrors({ wrongOldPassword: false });

      updates.push(
        this
          .propertyService
          .updatePassword(
            this.property,
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
        tap(() => this.notification.success(_('PropertyAccount.Updated'), _('Action.Ok'), { verticalPosition: 'top' })),
      )
      .subscribe(() => this.form.controls.password.reset())
    ;
  }
}
