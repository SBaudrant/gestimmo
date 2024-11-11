import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { Observable } from 'rxjs';
import { NotificationService } from '@services/notification.service';
import { UserService } from '@services/user.service';
import { User } from '@entity/user.class';
import { Role } from '@enum/role.enum';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';

@Component({
  selector: 'app-user-form-dialog',
  templateUrl: './user-form-dialog.component.html',
  styleUrls: ['./user-form-dialog.component.scss'],
})
export class UserFormDialogComponent implements OnInit {

  public readonly Role = Role;

  isSaving = false;

  form = this.formBuilder.nonNullable.group({
    active: [true, Validators.required],
    firstName: ['', Validators.required],
    lastName: ['', Validators.required],
    email: ['', Validators.compose([Validators.required, Validators.email])],
    role: [Role.USER, Validators.required],
  });

  constructor(
    private dialogRef: MatDialogRef<UserFormDialogComponent>,
    private notificationService: NotificationService,
    private userService: UserService,
    private formBuilder: FormBuilder,
    @Inject(MAT_DIALOG_DATA) public user: User,
  ) {}

  ngOnInit() {
    this.form.patchValue(this.user);
  }

  saveUser() {
    this.isSaving = true;
    const isNew = !this.user.id;
    const user = Object.assign(new User(), {id: this.user.id}, this.form.getRawValue());
    const user$: Observable<User> = isNew ? this.userService.create(user) : this.userService.update(user);
    user$.subscribe({
      next: createdOrUpdatedUser => {
        const successMsgKey = isNew ? _('Users.CreateSuccess') : _('Users.EditSuccess');
        this.notificationService.success(successMsgKey);
        this.dialogRef.close(createdOrUpdatedUser);
      },
      error: () => {
        const errorMsgKey = isNew ? _('Users.CreateError') : _('Users.EditError');
        this.notificationService.error(errorMsgKey);
      },
      complete: () => this.isSaving = false,
    });
  }

  onDismiss(): void {
    this.dialogRef.close();
  }
}
