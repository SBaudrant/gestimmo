import { Component, DestroyRef, OnInit } from '@angular/core';

import { takeUntilDestroyed } from '@angular/core/rxjs-interop';
import { NavigationEnd, Router, RouterModule } from '@angular/router';
import { AuthenticationService } from '@services/authentication.service';
import { Role } from '@enum/role.enum';
import { filter } from 'rxjs';
import { RoleGuard } from '@guards/role.guard';

@Component({
  selector: 'app-secured-layout',
  templateUrl: './secured-layout.component.html',
  styleUrls: ['./secured-layout.component.scss'],
})
export class SecuredLayoutComponent implements OnInit {
  public currentUser$ = this.authService.user$;
  public isAdmin$ = this.roleGuard.isAllowed([Role.ADMIN]);
  public canMassEdit = false;
  public isOpenMenu = false;

  constructor(
    private destroyRef: DestroyRef,
    private authService: AuthenticationService,
    private roleGuard: RoleGuard,
    private router: Router,
  ) { }

  ngOnInit(): void {
    this.router.events.pipe(
      filter(event => event instanceof NavigationEnd),
      takeUntilDestroyed(this.destroyRef),
    ).subscribe(() => this.isOpenMenu = false);
  }

  logout() {
    this.authService.logout();
  }
}
