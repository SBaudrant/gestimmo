import { Component, Input } from '@angular/core';
import { ThemePalette } from '@angular/material/core';
import { MatProgressSpinnerModule, ProgressSpinnerMode } from '@angular/material/progress-spinner';

@Component({
  standalone: true,
  selector: 'app-loader',
  templateUrl: './loader.component.html',
  styleUrls: ['./loader.component.scss'],
  imports: [
    MatProgressSpinnerModule
  ]
})
export class LoaderComponent {

  @Input({required: true}) loading: boolean;
  @Input() pageLoading = false;
  @Input() size = 20;
  @Input() color: ThemePalette = 'primary';
  @Input() invert = false;

  mode: ProgressSpinnerMode = 'indeterminate';
}
