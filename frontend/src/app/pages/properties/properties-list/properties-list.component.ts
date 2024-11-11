import { Component, DestroyRef, OnInit, Renderer2 } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { MatDialog } from '@angular/material/dialog';
import { PropertyFormDialogComponent } from '../property-form-dialog/property-form-dialog.component';
import { PropertiesListDataSource } from './properties-list.data-source';
import { debounceTime, filter, finalize, switchMap, tap } from 'rxjs/operators';
import { Property } from '@entity/property.class';
import { PropertyFilters } from '@filter/property-filters.class';
import { EntityListComponent } from '@components/entity-list/entity-list.component';
import { PropertyService } from '../../../services/property.service';
import { NotificationService } from '../../../services/notification.service';
import { ConfirmDialogComponent } from '@components/confirm-dialog/confirm-dialog.component';
import { Role } from '@enum/role.enum';
import { TranslocoService } from '@ngneat/transloco';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';

@Component({
  selector: 'app-properties-list',
  templateUrl: './properties-list.component.html',
  styleUrls: ['./properties-list.component.scss'],
})
export class PropertiesListComponent extends EntityListComponent<Property> implements OnInit {
  displayedColumns = ['firstName', 'lastName', 'email', 'role', 'active', 'actions'];
  showFilters = false;
  roles: Role[];

  form = this.formBuilder.nonNullable.group({
    search: [''],
    role: this.formBuilder.nonNullable.control<Role | null>(null),
  });

  constructor(
    destroyRef: DestroyRef,
    dataSource: PropertiesListDataSource,
    public dialog: MatDialog,
    private propertyService: PropertyService,
    private notificationService: NotificationService,
    private translate: TranslocoService,
    private formBuilder: FormBuilder,
    private renderer: Renderer2,
  ) {
    super(destroyRef, dataSource);
  }

  public ngOnInit(): void {
    this.initFilters();
    this.sortConfig = { property: 'lastName', direction: 'asc' };
    this.roles = this.propertyService.getRoles();
  }

  public reset(): void {
    this.sortConfig = { property: 'lastName', direction: 'asc' };
    this.form.reset();
  }

  public openEditDialog(property: Property): void {
    // On créé une copie de l'objet property avant de l'envoyer au formulaire pour éviter que l'utilisateur soit modifié dans la liste
    // tant que les changements n'ont pas été enregistrés par le backend
    const propertyToUpdate = Object.assign(new Property(), property);

    this.openPropertyFormDialog(propertyToUpdate);
  }

  public openAddDialog(): void {
    const property = new Property();
    property.active = true;
    this.openPropertyFormDialog(property);
  }

  public deleteProperty(property: Property): void {
    this
      .dialog
      .open(
        ConfirmDialogComponent,
        {
          data: {
            message: this.translate.translate('Properties.ConfirmDelete', {propertyFullName: `${property.firstName} ${property.lastName}`}),
            confirmAction: this.translate.translate('Action.Delete'),
            confirmColor: 'warn',
          },
        },
      )
      .afterClosed()
      .pipe(
        filter(isConfirmed => isConfirmed),
        tap(() => this.isSaving = true),
        switchMap(() => this.propertyService.delete(property)),
        finalize(() => this.isSaving = false),
      )
      .subscribe({
        next: () => {
          this.notificationService.success(_('Properties.DeleteSuccess'));
          this.refresh();
        },
        error: () => {
          this.notificationService.error(_('Properties.DeleteError'));
        },
      })
    ;
  }

  public openPropertyFormDialog(property: Property): void {
    this
      .dialog
      .open(
        PropertyFormDialogComponent,
        {
          width: '500px',
          data: property,
        },
      )
      .afterClosed()
      .pipe(
        filter(createdOrUpdatedProperty => createdOrUpdatedProperty),
      )
      .subscribe(() => this.refresh())
    ;
  }

  public toggleClass(event, className: string): void {
    const hasClass = event.target.classList.contains(className);
    if (hasClass) {
      this.renderer.removeClass(event.target, className);
    } else {
      this.renderer.addClass(event.target, className);
    }
  }

  private initFilters(): void {
    this.form.valueChanges
      .pipe(
        debounceTime(350),
        takeUntilDestroyed(this.destroyRef),
      )
      .subscribe(() => {
        this.search();
      })
    ;
  }

  protected buildFiltersObject(): PropertyFilters {
    return this.form.getRawValue();
  }
}
