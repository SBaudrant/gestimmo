import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard } from './guards/auth.guard';
import { LoginComponent } from './pages/login/login.component';
import { SecuredLayoutComponent } from './pages/secured-layout/secured-layout.component';
import { InitPasswordComponent } from './pages/init-password/init-password.component';
import { RequestPasswordInitComponent } from './pages/request-password-init/request-password-init.component';
import { HomeComponent } from './pages/home/home.component';

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  { path: 'login', component: LoginComponent },
  { path: 'init_password', component: RequestPasswordInitComponent },
  { path: 'init_password/:token', component: InitPasswordComponent },
  {
    path: '',
    component: SecuredLayoutComponent,
    canActivate: [AuthGuard],
    children: [
      {path: 'home', component: HomeComponent},
      {path: 'users', loadChildren: () => import('./pages/users/users.module').then(m => m.UsersModule)},
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {})],
  exports: [RouterModule],
})
export class AppRoutingModule { }
