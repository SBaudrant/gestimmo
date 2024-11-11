import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { Observable } from 'rxjs';
import { NotificationService } from '@services/notification.service';
import { PropertyService } from '@services/property.service';
import { Property } from '@entity/property.class';
import { Role } from '@enum/role.enum';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';

@Component({
  selector: 'app-property-form-dialog',
  templateUrl: './property-form-dialog.component.html',
  styleUrls: ['./property-form-dialog.component.scss'],
})
export class PropertyFormDialogComponent implements OnInit {

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
    private dialogRef: MatDialogRef<PropertyFormDialogComponent>,
    private notificationService: NotificationService,
    private propertyService: PropertyService,
    private formBuilder: FormBuilder,
    @Inject(MAT_DIALOG_DATA) public property: Property,
  ) {}

  ngOnInit() {
    this.form.patchValue(this.property);
  }

  saveProperty() {
    this.isSaving = true;
    const isNew = !this.property.id;
    const property = Object.assign(new Property(), {id: this.property.id}, this.form.getRawValue());
    const property$: Observable<Property> = isNew ? this.propertyService.create(property) : this.propertyService.update(property);
    property$.subscribe({
      next: createdOrUpdatedProperty => {
        const successMsgKey = isNew ? _('Properties.CreateSuccess') : _('Properties.EditSuccess');
        this.notificationService.success(successMsgKey);
        this.dialogRef.close(createdOrUpdatedProperty);
      },
      error: () => {
        const errorMsgKey = isNew ? _('Properties.CreateError') : _('Properties.EditError');
        this.notificationService.error(errorMsgKey);
      },
      complete: () => this.isSaving = false,
    });
  }

  onDismiss(): void {
    this.dialogRef.close();
  }
}
