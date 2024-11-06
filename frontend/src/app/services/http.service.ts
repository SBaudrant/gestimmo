import { Injectable } from '@angular/core';
import { HttpClient, HttpEvent, HttpParams } from '@angular/common/http';

import { Observable } from 'rxjs';
import { map, pluck } from 'rxjs/operators';
import { Entity } from '../models/entity/entity.class';
import { ParametersService } from './parameters.service';
import { CollectionContext } from '../models/hydra/collection-context.class';
import { emptyForkJoin } from '../operator/empty-fork-join.operator';
import { aiif } from '../operator/aiif.operator';
import { isIri } from '../function/is-iri';
import { isObject } from '../function/is-object';
import { entityIri } from '../function/entity-iri';
import { NormalizerMap } from '../models/type/normalizer-map.type';
import { Shape } from '../models/type/shape.type';
import { DenormalizerMap } from '../models/type/denormalizer-map.type';
import { Clazz } from '../models/type/clazz.type';
import { ElementOrArrayType } from '../models/type/element-or-array.type';
import { ListOrder } from '../models/paginator/list-order.interface';
import { PaginatedResult } from '../models/paginator/paginated-result.class';
import { formatRFC3339, parseJSON } from 'date-fns';

type Filters<T, U> = Partial<T> | Partial<Shape<T>> | Partial<U>;

@Injectable({
  providedIn: 'root',
})
export abstract class HttpService<T extends Entity, U = { [p: string]: any }> {
  public static endpoint: string | null = null;

  constructor(
    protected readonly http: HttpClient,
    protected readonly parametersService: ParametersService,
  ) {
    HttpService.endpoint = parametersService.getApiHost();
  }

  public abstract getClass(): Clazz<T>;

  public abstract resourcePath(): string;

  public resourceUrl(t?: T, format?: string): string {
    let url = '' + HttpService.endpoint;

    if (!t) {
      url += this.resourcePath();
    } else if (t['@id']) {
      url += t['@id'].replace(/\/api/, '');
    } else {
      url += this.resourcePath() + '/' + t.id;
    }

    if (format) {
      url += '.' + format;
    }

    return url;
  }

  public findByPaginated(
    pageIndex: number,
    pageSize: number,
    filters: Filters<T, U>,
    orders?: ElementOrArrayType<ListOrder<T & U>>,
  ): Observable<PaginatedResult<T>> {
    return this
      .http
      .get<CollectionContext<T>>(
      this.resourceUrl(),
      { params: this.buildHttpParams(undefined, pageIndex, pageSize, filters, orders) },
    )
      .pipe(
        map((result) => new PaginatedResult<T>(
          result['hydra:member'].map(this.denormalize.bind(this)),
          result['hydra:totalItems'],
          pageSize,
          pageIndex,
        )),
      )
    ;
  }

  public count(filters: Filters<T, U> = <Filters<T, U>> {}): Observable<number> {
    return this
      .findByPaginated(
        1,
        0,
        filters,
      )
      .pipe(
        pluck('itemsCount'),
      )
    ;
  }

  public findBy(
    filters: Filters<T, U> = <Filters<T, U>> {},
    orders?: ElementOrArrayType<ListOrder<T & U>>,
  ): Observable<T[]> {
    return <Observable<T[]>> this
      .http
      .get<CollectionContext<T>>(
      this.resourceUrl(),
      {
        params: this.buildHttpParams(undefined, undefined, undefined, filters, orders),
      },
    )
      .pipe(
        pluck('hydra:member'),
        map(ts => ts.map(this.denormalize.bind(this))),
      )
    ;
  }

  public findOneBy(filters: Filters<T, U>): Observable<T | null> {
    return this
      .findByPaginated(1, 1, filters)
      .pipe(
        map(pr => {
          if (pr.itemsCount > 1) {
            throw new Error('Method findOneBy cannot chose between elements if there are more than one.');
          }

          return pr.items[0] || null;
        }),
      )
    ;
  }

  public findById(id: T['id'] | T['@id']): Observable<T> {
    const url = isIri(id)
      ? HttpService.endpoint + id
      : this.resourceUrl() + '/' + id
    ;

    return this
      .http
      .get<T>(url)
      .pipe(
        map(t => this.denormalize(t)),
      )
    ;
  }

  public find<V extends(T | T[])>(v: V): Observable<V> {
    return <Observable<V>> (
      Array.isArray(v)
        ? this.findBy(<U> <any> { id: v })
        : this.findById(v['@id'])
    );
  }

  public export(
    format: string,
    filters: Filters<T, U> = <Filters<T, U>> {},
    orders?: ElementOrArrayType<ListOrder<T & U>>,
  ): Observable<HttpEvent<Blob>> {
    return this
      .http
      .get(
        this.resourceUrl(undefined, format),
        {
          params: this.buildHttpParams(undefined, undefined, undefined, filters, orders),
          observe: 'events',
          responseType: 'blob',
          reportProgress: true,
        },
      )
    ;
  }

  public create(t: T): Observable<T>;
  public create(t: T[]): Observable<T[]>;
  public create(t: T | T[]): Observable<T | T[]> {
    if (Array.isArray(t)) {
      return emptyForkJoin(t.map(e => this.create(e)));
    }

    return this
      .http
      .post<T>(
      this.resourceUrl(),
      this.normalize(t),
    )
      .pipe(
        map(created => this.denormalize(created)),
      )
    ;
  }

  public update(t: T): Observable<T>;
  public update(t: T[]): Observable<T[]>;
  public update(t: T | T[]): Observable<T | T[]> {
    if (Array.isArray(t)) {
      return emptyForkJoin(t.map(e => this.update(e)));
    }

    return this
      .http
      .patch<T>(
      this.resourceUrl(t),
      this.normalize(t),
    )
      .pipe(
        map(updated => this.denormalize(updated)),
      )
    ;
  }

  public save(t: T): Observable<T>;
  public save(t: T[]): Observable<T[]>;
  public save(t: T | T[]): Observable<T | T[]> {
    if (Array.isArray(t)) {
      return emptyForkJoin(t.map(e => this.save(e)));
    }

    return aiif(
      () => typeof t['@id'] === 'string',
      () => this.update(t),
      () => this.create(t),
    );
  }

  public delete(t: T): Observable<void>;
  public delete(t: T[]): Observable<void[]>;
  public delete(t: T | T[]): Observable<void | void[]> {
    if (Array.isArray(t)) {
      return emptyForkJoin(t.map(e => this.delete(e)));
    }

    return this
      .http
      .delete<void>(this.resourceUrl(t))
    ;
  }

  /**
   * @internal
   */
  public normalize(t: T): Shape<T> {
    const normalizers = this.getNormalizers();

    if (typeof t === 'object') {
      return Object
        .keys(t)
        .reduce(
          (normalized, p) => Object.assign(
            normalized,
            {
              [p]: normalizers[p] !== undefined
                ? normalizers[p](t[p], p, t)
                : this.defaultNormalizer(t[p]),
            },
          ),
          <Shape<T>> {},
        )
      ;
    }

    return this.defaultNormalizer(t);
  }

  protected defaultNormalizer<P extends keyof T>(tp: T[P]): any {
    if (Array.isArray(tp)) {
      return tp.map(v => this.defaultNormalizer(v));
    }

    if (tp instanceof Date) {
      return formatRFC3339(tp);
    }

    if (isObject(tp)) {
      return entityIri(<Entity> <unknown> tp);
    }

    return tp;
  }

  protected getNormalizers(): NormalizerMap<T> {
    return {};
  }

  /**
   * @internal
   */
  public denormalize(t: Shape<T>): T {
    const denormalizers = this.getDenormalizers();

    if (isObject(t)) {
      const instance = Object.assign(
        new (this.getClass())(),
        t,
      );

      return Object
        .keys(t)
        .reduce(
          (denormalized, p) => Object.assign(
            denormalized,
            {
              [p]: denormalizers[p] !== undefined
                ? denormalizers[p](t[p], p, t)
                : this.defaultDenormalizer(t[p], <keyof T> p),
            },
          ),
          instance,
        )
      ;
    }

    return this.defaultDenormalizer(<any> t, undefined);
  }

  protected defaultDenormalizer<P extends keyof T>(tp: T[P], p: P | undefined): any {
    if (Array.isArray(tp)) {
      return tp.map(v => this.defaultDenormalizer(v, undefined));
    }

    if (typeof tp === 'string') {
      if (p !== '@id' && isIri(tp)) {
        return { ['@id']: tp };
      }

      if (/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/.test(tp)) {
        return parseJSON(tp);
      }
    }

    if (!isObject(tp)) {
      return tp;
    }


    let entity = <Entity> <unknown> tp;

    entity = Object
      .keys(entity)
      .reduce(
        (denormalized, property) => Object.assign(
          denormalized,
          {
            [property]: this.defaultDenormalizer(entity[property], <keyof T> property),
          },
        ),
        entity,
      )
    ;

    return entity;
  }

  protected getDenormalizers(): DenormalizerMap<T> {
    return {};
  }

  protected buildHttpParams(
    httpParams?: HttpParams,
    pageIndex?: number,
    pageSize?: number,
    filters?: Filters<T, U>,
    orders?: ElementOrArrayType<ListOrder<T & U>>,
  ): HttpParams {
    httpParams = httpParams || new HttpParams();

    if (pageIndex === undefined && pageSize === undefined) {
      httpParams = httpParams.set('pagination', 'false');
    } else {
      if (pageIndex !== undefined) {
        httpParams = httpParams.set('page', pageIndex.toString());
      }

      if (pageSize !== undefined) {
        httpParams = httpParams.set('itemsPerPage', pageSize.toString());
      }
    }

    if (filters !== undefined) {
      const paramSanitizer = ([param, value]) => {
        if (Array.isArray(value)) {
          value = value.map(v => paramSanitizer([undefined, v])[1]);
        } else if (value instanceof Date) {
          value = formatRFC3339(value);
        } else if (isObject(value)) {
          value = entityIri(value);
        }

        return <[string, string | string[]]> [param, value];
      };

      httpParams = Object
        .entries(filters)
        .filter(([, value]) => value !== null && value !== '' && value !== undefined)
        .map(paramSanitizer)
        .reduce(
          (params, [param, value]) => {
            if (Array.isArray(value)) {
              param += '[]';
              return value.reduce((acc, v) => acc.append(param, v), params);
            }

            return params.append(param, value);
          },
          httpParams,
        )
      ;
    }

    if (orders !== undefined) {
      if (Array.isArray(orders)) {
        httpParams = orders.reduce(
          (params, order) => params.set(`order[${String(order.property)}]`, order.direction),
          httpParams,
        );
      } else {
        httpParams = httpParams.set(`order[${String(orders.property)}]`, orders.direction);
      }
    }

    return httpParams;
  }
}
