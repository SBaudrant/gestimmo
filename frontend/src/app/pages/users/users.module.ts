// Angular core
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

// Our modules
import { UsersRoutingModule } from './users-routing.module';

// Our components
import { UserFormDialogComponent } from './user-form-dialog/user-form-dialog.component';
import { UsersListComponent } from './users-list/users-list.component';
import { UserAccountComponent } from './user-account/user-account.component';
import { SharedModule } from '../shared.module';

@NgModule({
  imports: [
    CommonModule,
    SharedModule,
    UsersRoutingModule,
  ],
  declarations: [
    UserFormDialogComponent,
    UsersListComponent,
    UserAccountComponent,
  ],
})
export class UsersModule { }
