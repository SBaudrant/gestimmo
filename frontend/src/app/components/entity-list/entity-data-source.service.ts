import { Injectable } from '@angular/core';
import { CollectionViewer, DataSource } from '@angular/cdk/collections';
import { BehaviorSubject, Observable, of, Subject, Subscription } from 'rxjs';
import { catchError, finalize } from 'rxjs/operators';
import { Entity } from '../../models/entity/entity.class';
import { AbstractFilters } from '../../models/filter/abstract-filters.class';
import { ListOrder } from '../../models/paginator/list-order.interface';
import { HttpService } from '../../services/http.service';
import { PaginatedResult } from '../../models/paginator/paginated-result.class';

interface Paginator {
  pageIndex: number;
  pageSize: number;
  length: number;
}

@Injectable({
  providedIn: 'root',
})
export abstract class EntityDataSource<T extends Entity> implements DataSource<T> {
  private loadingSubject$: Subject<boolean> = new BehaviorSubject<boolean>(true);
  public loading$: Observable<boolean> = this.loadingSubject$.asObservable();

  private entitiesSubject$: Subject<T[]>;
  private current: { paginator: Paginator; filters: AbstractFilters<T>; order?: ListOrder<T> };
  private request: Subscription | null;

  protected constructor(
    protected readonly httpService: HttpService<T>,
  ) { }

  public get entities$(): Observable<T[]> {
    return this
      .entitiesSubject$
      .asObservable()
    ;
  }

  public connect(collectionViewer: CollectionViewer): Observable<T[]> {
    this.entitiesSubject$ = new BehaviorSubject<T[]>([]);

    return this.entities$;
  }

  public disconnect(collectionViewer: CollectionViewer): void {
    this.entitiesSubject$.complete();
    this.loadingSubject$.next(true);
  }

  public load(paginator: Paginator, filters: AbstractFilters<T>, order?: ListOrder<T>): void {
    this.current = {
      paginator,
      filters,
      order,
    };

    this.loadingSubject$.next(true);

    this.entitiesSubject$.next([]);

    // Cancel http request if there is one ongoing
    if (this.request) {
      this.request.unsubscribe();
    }

    this.request = this
      .httpService
      .findByPaginated(paginator.pageIndex + 1, paginator.pageSize, filters, order)
      .pipe(
        catchError(error => {
          // eslint-disable-next-line
          console.error(error);

          return of(new PaginatedResult([], 1, 1, 0));
        }),
        finalize(() => this.loadingSubject$.next(false)),
      )
      .subscribe(entities => {
        paginator.length = entities.itemsCount;
        this.entitiesSubject$.next(entities.items);
        this.request = null;
      })
    ;
  }

  /**
   * Force a refresh from API
   */
  public reload() {
    if (!this.current) {
      return;
    }

    this.load(this.current.paginator, this.current.filters, this.current.order);
  }
}
