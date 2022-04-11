import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import { Observable, of } from 'rxjs';
import { ColorFormatService } from '../services/color-format.service';
import { ColorFormat } from '../shared/enums/color-format';

@Injectable({
  providedIn: 'root'
})
export class ColorFormatResolver implements Resolve<any> {

  constructor(private colorFormatService: ColorFormatService) {}
  resolve(route: ActivatedRouteSnapshot): Observable<any> {
    return this.colorFormatService.getFormats();
  }
}
