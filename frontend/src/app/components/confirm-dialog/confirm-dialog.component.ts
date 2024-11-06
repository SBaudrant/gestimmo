import { Component, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { ThemePalette } from '@angular/material/core';
import { TranslocoService } from '@ngneat/transloco';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { CommonModule } from '@angular/common';

@Component({
  standalone: true,
  selector: 'app-confirm-dialog',
  templateUrl: './confirm-dialog.component.html',
  styleUrls: ['./confirm-dialog.component.scss'],
  imports: [
    MatIconModule,
    MatButtonModule,
    CommonModule
  ]
})
export class ConfirmDialogComponent {

  title: string;
  message: string;
  confirmAction: string;
  cancelAction: string;
  confirmColor: ThemePalette;
  displayCancelButton: boolean;
  displayCloseButton: boolean;

  constructor(
    private dialogRef: MatDialogRef<ConfirmDialogComponent>,
    @Inject(MAT_DIALOG_DATA)
    data: {
      title?: string;
      message: string;
      confirmAction?: string;
      confirmColor?: ThemePalette;
      cancelAction?: string;
      displayCancelButton?: boolean;
      displayCloseButton?: boolean;
    },
    private translate: TranslocoService,
  ) {
    this.title = data.title || this.translate.translate('Action.Confirm');
    this.message = data.message;
    this.confirmAction = data.confirmAction || this.translate.translate('Action.Yes');
    this.confirmColor = data.confirmColor || 'primary';
    this.cancelAction = data.cancelAction || this.translate.translate('Action.Cancel');
    this.displayCancelButton = data.displayCancelButton ?? true;
    this.displayCloseButton = data.displayCloseButton ?? true;
  }

  onConfirm(): void {
    this.dialogRef.close(true);
  }

  onDismiss(): void {
    this.dialogRef.close(false);
  }
}
