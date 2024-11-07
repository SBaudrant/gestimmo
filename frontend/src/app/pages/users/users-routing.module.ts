import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { Role } from '@enum/role.enum';
import { UsersListComponent } from './users-list/users-list.component';
import { RoleGuard } from '@guards/role.guard';
import { UserAccountComponent } from './user-account/user-account.component';

const routes: Routes = [
  {path: '', component: UsersListComponent, canActivate: [RoleGuard], data: {allowedRoles: [Role.ADMIN]}},
  {path: 'my-account', component: UserAccountComponent, canActivate: [RoleGuard], data: { allowedRoles: [Role.USER] } },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class UsersRoutingModule { }
