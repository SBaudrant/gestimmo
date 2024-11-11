import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { filter, finalize, map, switchMap } from 'rxjs/operators';
import { FormBuilder, Validators } from '@angular/forms';
import { tooWeakValidator } from '@validators/too-weak-validator';
import { AuthenticationService } from '@services/authentication.service';
import { NotificationService } from '@services/notification.service';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';
import { PagesModule } from '@pages.module';

@Component({
  selector: 'app-reset-password',
  templateUrl: './init-password.component.html',
  styleUrls: [ './init-password.component.scss'],
})
export class InitPasswordComponent {
  public isLoading = false;
  public form = this.formBuilder.nonNullable.group(
    {
      password: ['', [Validators.required, Validators.minLength(8), tooWeakValidator]],
      passwordConfirmation: ['', Validators.required],
    },
    {
      validators: [
        group => group.value.password === group.value.passwordConfirmation ? null : { notSame: true },
      ],
    },
  );

  constructor(
    protected readonly formBuilder: FormBuilder,
    protected readonly route: ActivatedRoute,
    protected readonly authentication: AuthenticationService,
    protected readonly notification: NotificationService,
    protected readonly router: Router,
  ) { }

  public onSubmit(): void {
    if (this.form.invalid) {
      return;
    }

    this.isLoading = true;

    const formValues = this.form.getRawValue();

    this
      .route
      .paramMap
      .pipe(
        finalize(() => this.isLoading = false),
        map(paramMap => paramMap.get('token')),
        filter((token): token is string => token !== null),
        switchMap(token => this.authentication.initPasswordWithToken(token, formValues.password)),
      )
      .subscribe({
        next: () => {
          this
            .notification
            .success(_('InitPassword.PasswordInit'), _('Action.Ok'), { verticalPosition: 'top' })
          ;
          this.router.navigate(['/login']);
        },
        error: () => {
          this.notification.error(_('InitPassword.BadRequest'), _('Action.Ok'), { verticalPosition: 'top' });
        },
      })
    ;
  }
}
