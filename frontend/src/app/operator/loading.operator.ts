import { Subject } from 'rxjs';
import { LoadingProgress } from '@interface/loading-progress.interface';
import { tap } from 'rxjs/operators';
import { HttpEvent, HttpEventType } from '@angular/common/http';

export const httpLoading = (loading$: Subject<LoadingProgress | null | undefined>) => tap<HttpEvent<any>>(httpEvent => {
  switch (httpEvent.type) {
    case HttpEventType.Sent:
      loading$.next(null);
      break;

    case HttpEventType.DownloadProgress:
    case HttpEventType.UploadProgress:
      loading$.next({
        loaded: httpEvent.loaded,
        total: httpEvent.total,
      });
      break;

    case HttpEventType.Response:
      loading$.next(undefined);
      break;
  }
});
