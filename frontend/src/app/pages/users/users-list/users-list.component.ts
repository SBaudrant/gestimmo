import { Component, DestroyRef, OnInit, Renderer2 } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { MatDialog } from '@angular/material/dialog';
import { UserFormDialogComponent } from '../user-form-dialog/user-form-dialog.component';
import { UsersListDataSource } from './users-list.data-source';
import { debounceTime, filter, finalize, switchMap, tap } from 'rxjs/operators';
import { User } from '@entity/user.class';
import { UserFilters } from '@filter/user-filters.class';
import { EntityListComponent } from '@components/entity-list/entity-list.component';
import { UserService } from '@services/user.service';
import { NotificationService } from '@services/notification.service';
import { ConfirmDialogComponent } from '@components/confirm-dialog/confirm-dialog.component';
import { Role } from '@enum/role.enum';
import { TranslocoService } from '@ngneat/transloco';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';

@Component({
  selector: 'app-users-list',
  templateUrl: './users-list.component.html',
  styleUrls: ['./users-list.component.scss'],
})
export class UsersListComponent extends EntityListComponent<User> implements OnInit {
  displayedColumns = ['firstName', 'lastName', 'email', 'role', 'active', 'actions'];
  showFilters = false;
  roles: Role[];

  form = this.formBuilder.nonNullable.group({
    search: [''],
    role: this.formBuilder.nonNullable.control<Role | null>(null),
  });

  constructor(
    destroyRef: DestroyRef,
    dataSource: UsersListDataSource,
    public dialog: MatDialog,
    private userService: UserService,
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
    this.roles = this.userService.getRoles();
  }

  public reset(): void {
    this.sortConfig = { property: 'lastName', direction: 'asc' };
    this.form.reset();
  }

  public openEditDialog(user: User): void {
    // On créé une copie de l'objet user avant de l'envoyer au formulaire pour éviter que l'utilisateur soit modifié dans la liste
    // tant que les changements n'ont pas été enregistrés par le backend
    const userToUpdate = Object.assign(new User(), user);

    this.openUserFormDialog(userToUpdate);
  }

  public openAddDialog(): void {
    const user = new User();
    user.active = true;
    this.openUserFormDialog(user);
  }

  public deleteUser(user: User): void {
    this
      .dialog
      .open(
        ConfirmDialogComponent,
        {
          data: {
            message: this.translate.translate('Users.ConfirmDelete', {userFullName: `${user.firstName} ${user.lastName}`}),
            confirmAction: this.translate.translate('Action.Delete'),
            confirmColor: 'warn',
          },
        },
      )
      .afterClosed()
      .pipe(
        filter(isConfirmed => isConfirmed),
        tap(() => this.isSaving = true),
        switchMap(() => this.userService.delete(user)),
        finalize(() => this.isSaving = false),
      )
      .subscribe({
        next: () => {
          this.notificationService.success(_('Users.DeleteSuccess'));
          this.refresh();
        },
        error: () => {
          this.notificationService.error(_('Users.DeleteError'));
        },
      })
    ;
  }

  public openUserFormDialog(user: User): void {
    this
      .dialog
      .open(
        UserFormDialogComponent,
        {
          width: '500px',
          data: user,
        },
      )
      .afterClosed()
      .pipe(
        filter(createdOrUpdatedUser => createdOrUpdatedUser),
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

  protected buildFiltersObject(): UserFilters {
    return this.form.getRawValue();
  }
}
