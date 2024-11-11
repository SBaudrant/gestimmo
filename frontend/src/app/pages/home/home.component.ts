import { Component } from '@angular/core';
import { NotificationService } from '@services/notification.service';
import { CommonModule } from '@angular/common';
import { MatDialog } from '@angular/material/dialog';
import { ConfirmDialogComponent } from '@components/confirm-dialog/confirm-dialog.component';
import { MatCardModule } from '@angular/material/card';
import { MatFormFieldModule } from '@angular/material/form-field';
import { LoaderComponent } from '@components/loader/loader.component';
import { MatIconModule } from '@angular/material/icon';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
})
export class HomeComponent {

  constructor(
    public notificationService: NotificationService,
    public dialog: MatDialog,
  ) {}

  public openSnackBarSuccess(): void {
    this.notificationService.success('Ceci est un message de succès.', 'Action.Back', { horizontalPosition: 'right'});
  }

  public openSnackBarInfo(): void {
    this.notificationService.info('Ceci est un message d\'information.', 'Action.Back', {horizontalPosition: 'right'});
  }

  public openSnackBarWarning(): void {
    this.notificationService.warning('Ceci est un message d\'alerte.', 'Action.Back', {horizontalPosition: 'right'});
  }

  public openSnackBarDanger(): void {
    this.notificationService.error('Ceci est un message d\'erreur.', 'Action.Back', {horizontalPosition: 'right'});
  }

  public openDialog() {
    this.dialog
      .open(ConfirmDialogComponent, {
        data: {
          title: 'Dialotig title',
          message: 'Dialog content message',
          confirmAction: 'Oui',
          cancelAction: 'Non',
          displayCancelButton: true,
          displayCloseButton: true,
        },
        width: '500px',
      });
  }

}
