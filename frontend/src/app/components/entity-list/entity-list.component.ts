import { AfterViewInit, Component, DestroyRef, ViewChild } from '@angular/core';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort, Sort } from '@angular/material/sort';
import { MatTable } from '@angular/material/table';
import { Entity } from '../../models/entity/entity.class';
import { AbstractFilters } from '../../models/filter/abstract-filters.class';
import { ListOrder } from '../../models/paginator/list-order.interface';
import { ObservableInput, merge } from 'rxjs';
import { EntityDataSource } from './entity-data-source.service';

@Component({
  template: '',
})
export abstract class EntityListComponent<T extends Entity> implements AfterViewInit {
  public readonly PAGE_SIZE = 20;

  public isSaving = false;
  public sortConfig: ListOrder<T>;
  public filters: AbstractFilters<T>;

  @ViewChild(MatPaginator, { static: false })
  public paginator: MatPaginator;

  @ViewChild(MatTable, { static: false })
  public table: MatTable<T>;

  @ViewChild(MatSort, { static: false })
  public sort: MatSort;

  constructor(
    protected destroyRef: DestroyRef,
    public readonly dataSource: EntityDataSource<T>,
  ) { }

  public ngAfterViewInit(): void {
    this.dataSource.load(this.paginator, this.buildFiltersObject(), this.sortConfig);

    merge(this.paginator.page, this.sort.sortChange as ObservableInput<Sort>)
      .pipe(takeUntilDestroyed(this.destroyRef))
      .subscribe(() => this.dataSource.load(
        this.paginator,
        this.buildFiltersObject(),
        this.getSortOrder(),
      ))
    ;
  }

  public refresh(): void {
    this.dataSource.reload();
  }

  public search(): void {
    if (this.paginator.pageIndex === 0) {
      this.dataSource.load(this.paginator, this.buildFiltersObject(), this.sortConfig);
    } else {
      this.paginator.firstPage();
    }
  }

  protected getSortOrder(): ListOrder<T> | undefined {
    if (typeof this.sort.active !== 'undefined' && this.sort.direction !== '') {
      return {
        property: this.sort.active,
        direction: this.sort.direction,
      };
    }

    return undefined;
  }

  protected abstract buildFiltersObject(): AbstractFilters<T>;
}
