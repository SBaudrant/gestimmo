import { Injectable } from '@angular/core';
import { MatSnackBar, MatSnackBarConfig, MatSnackBarRef, SimpleSnackBar } from '@angular/material/snack-bar';
import { TranslocoService } from '@ngneat/transloco';

@Injectable({
  providedIn: 'root',
})
export class NotificationService {
  constructor(
    protected readonly snackBar: MatSnackBar,
    protected readonly translate: TranslocoService,
  ) {}

  public success(
    message: string,
    action?: string,
    config?: MatSnackBarConfig,
  ): MatSnackBarRef<SimpleSnackBar> {
    return this.openSnackBar(message, action, { panelClass: ['snackbar-success'], ...config });
  }

  public error(
    message: string,
    action?: string,
    config?: MatSnackBarConfig,
  ): MatSnackBarRef<SimpleSnackBar> {
    return this.openSnackBar(message, action, { panelClass: ['snackbar-danger'], ...config });
  }

  public info(
    message: string,
    action?: string,
    config?: MatSnackBarConfig,
  ): MatSnackBarRef<SimpleSnackBar> {
    return this.openSnackBar(message, action, { panelClass: ['snackbar-info'], ...config });
  }

  public warning(
    message: string,
    action?: string,
    config?: MatSnackBarConfig,
  ): MatSnackBarRef<SimpleSnackBar> {
    return this.openSnackBar(message, action, { panelClass: ['snackbar-warning'], ...config });
  }

  protected openSnackBar(
    message: string,
    action?: string,
    config?: MatSnackBarConfig,
  ): MatSnackBarRef<SimpleSnackBar> {
    return this.snackBar.open(
      this.translate.translate(message),
      action ? this.translate.translate(action) : action,
      config,
    );
  }
}
