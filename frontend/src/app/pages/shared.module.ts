// Angular core
import { APP_INITIALIZER, NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';

// Third party
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { MatButtonModule } from '@angular/material/button';
import { MatCardModule } from '@angular/material/card';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { DateAdapter, MAT_DATE_LOCALE, MatNativeDateModule } from '@angular/material/core';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatDialogModule } from '@angular/material/dialog';
import { MatExpansionModule } from '@angular/material/expansion';
import { MatIconModule } from '@angular/material/icon';
import { MatInputModule } from '@angular/material/input';
import { MatListModule } from '@angular/material/list';
import { MatPaginatorIntl, MatPaginatorModule } from '@angular/material/paginator';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatRadioModule } from '@angular/material/radio';
import { MatSelectModule } from '@angular/material/select';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MAT_SNACK_BAR_DEFAULT_OPTIONS, MatSnackBarModule } from '@angular/material/snack-bar';
import { MatSortModule } from '@angular/material/sort';
import { MatTableModule } from '@angular/material/table';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatTooltipModule } from '@angular/material/tooltip';
import { DateFnsAdapter, MatDateFnsModule } from '@angular/material-date-fns-adapter';
import { fr } from 'date-fns/locale';
import { marker as _ } from '@ngneat/transloco-keys-manager/marker';

// Our components
import { ConfirmDialogComponent } from '@components/confirm-dialog/confirm-dialog.component';
import { LoaderComponent } from '@components/loader/loader.component';

// Our services
import { environment } from '../../environments/environment';
import { ParametersService } from '../services/parameters.service';
import { TranslocoModule, TranslocoService } from '@ngneat/transloco';
import { firstValueFrom } from 'rxjs';

// Load assets/parameters.json file
export function ConfigLoader(parameterService: ParametersService) {
  return () => parameterService.load(environment.parametersFile);
}

export function preloadTranslations(transloco: TranslocoService) {
  return () => {
    transloco.setActiveLang('fr');
    return firstValueFrom(transloco.load('fr'));
  };
}

// Init pagination
export function getTranslatePaginatorIntl(translate: TranslocoService) {
  // Les clés utilisées dans ce service ne sont pas correctement détectées par le key-manager
  // On utilise donc le marker
  const paginatorIntl = new MatPaginatorIntl();
  paginatorIntl.itemsPerPageLabel = translate.translate(_('Paginator.ItemsPerPage'));
  paginatorIntl.firstPageLabel = translate.translate(_('Paginator.FirstPage'));
  paginatorIntl.previousPageLabel = translate.translate(_('Paginator.PreviousPage'));
  paginatorIntl.nextPageLabel = translate.translate(_('Paginator.NextPage'));
  paginatorIntl.lastPageLabel = translate.translate(_('Paginator.LastPage'));

  paginatorIntl.getRangeLabel = (pageNumber, pageSize, length) => translate.translate(_('Paginator.Range'), {
    from: pageNumber * pageSize + 1,
    to: (pageNumber * pageSize + pageSize) < length ? (pageNumber * pageSize + pageSize) : length,
    length,
  });
  return paginatorIntl;
}

@NgModule({
  declarations: [
  ],
  imports: [
    // Angular core
    CommonModule,
    FormsModule,
    HttpClientModule,
    ReactiveFormsModule,
    // Angular Material
    MatButtonModule,
    MatCardModule,
    MatIconModule,
    MatInputModule,
    MatTableModule,
    MatToolbarModule,
    MatPaginatorModule,
    MatProgressSpinnerModule,
    MatSortModule,
    MatSelectModule,
    MatAutocompleteModule,
    MatCheckboxModule,
    MatTooltipModule,
    MatSnackBarModule,
    MatRadioModule,
    MatListModule,
    MatDialogModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatSidenavModule,
    MatExpansionModule,
    // Third party
    TranslocoModule,

    // Our Global components 
    ConfirmDialogComponent,
    LoaderComponent,
  ],
  exports: [
    // Angular core
    CommonModule,
    FormsModule,
    HttpClientModule,
    // Angular Material
    MatButtonModule,
    MatCardModule,
    MatIconModule,
    MatInputModule,
    MatTableModule,
    MatToolbarModule,
    MatPaginatorModule,
    MatProgressSpinnerModule,
    MatSortModule,
    ReactiveFormsModule,
    MatSelectModule,
    MatAutocompleteModule,
    MatCheckboxModule,
    MatTooltipModule,
    MatSnackBarModule,
    MatRadioModule,
    MatListModule,
    MatDialogModule,
    MatDatepickerModule,
    MatDateFnsModule,
    MatSidenavModule,
    MatExpansionModule,
    TranslocoModule,
    // Our components
    ConfirmDialogComponent,
    LoaderComponent,
  ],
  providers: [
    // DateFns
    {
      provide: DateAdapter,
      useClass: DateFnsAdapter,
      deps: [MAT_DATE_LOCALE],
    },
    // Angular Material
    {
      provide: MatPaginatorIntl,
      useFactory: getTranslatePaginatorIntl,
      deps: [TranslocoService],
    },
    {
      provide: MAT_SNACK_BAR_DEFAULT_OPTIONS,
      useValue: { duration: 5000 },
    },
    {
      provide: MAT_DATE_LOCALE,
      useValue: fr,
    },
    MatDatepickerModule,
    // Our services
    {
      provide: APP_INITIALIZER,
      useFactory: ConfigLoader,
      deps: [ParametersService],
      multi: true,
    },
    {
      provide: APP_INITIALIZER,
      multi: true,
      useFactory: preloadTranslations,
      deps: [TranslocoService],
    },
  ],
})
export class SharedModule {}
