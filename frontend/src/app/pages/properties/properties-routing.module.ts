import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { Role } from '@enum/role.enum';
import { PropertiesListComponent } from './properties-list/properties-list.component';
import { RoleGuard } from '@guards/role.guard';
import { PropertyAccountComponent } from './property-account/property-account.component';

const routes: Routes = [
  {path: '', component: PropertiesListComponent, canActivate: [RoleGuard], data: {allowedRoles: [Role.USER]}},
  {path: 'my-account', component: PropertyAccountComponent, canActivate: [RoleGuard], data: { allowedRoles: [Role.USER] } },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class PropertiesRoutingModule { }
