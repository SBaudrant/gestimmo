import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { AuthenticationService } from '@services/authentication.service';
import { NotificationService } from '@services/notification.service';
import { finalize } from 'rxjs/operators';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';


@Component({
  selector: 'app-request-password-reset',
  templateUrl: './request-password-init.component.html',
  styleUrls: ['./request-password-init.component.scss'],
})
export class RequestPasswordInitComponent {
  public isLoading = false;
  public form = this.formBuilder.nonNullable.group({
    email: [this.route.snapshot.queryParamMap.get('email') || '', [Validators.required, Validators.email]],
  });

  constructor(
    protected readonly formBuilder: FormBuilder,
    protected readonly authentication: AuthenticationService,
    protected readonly notification: NotificationService,
    protected readonly route: ActivatedRoute,
  ) { }

  public onSubmit(): void {
    if (this.form.invalid) {
      return;
    }

    this.isLoading = true;

    this
      .authentication
      .requestPasswordInit(this.form.getRawValue().email)
      .pipe(finalize(() => this.isLoading = false))
      .subscribe(() => {
        this.notification.success(_('RequestPasswordInit.RequestSend'), _('Action.Ok'), { verticalPosition: 'top' });
      })
    ;
  }
}
