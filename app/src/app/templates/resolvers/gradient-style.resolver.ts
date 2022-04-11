import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import { Observable, of } from 'rxjs';
import { GradientStyleService } from '../services/gradient-style.service';

@Injectable({
  providedIn: 'root'
})
export class GradientStyleResolver implements Resolve<boolean> {
  constructor(private gradientStyleService: GradientStyleService) {}

  resolve(route: ActivatedRouteSnapshot): Observable<any> {
    return this.gradientStyleService.getStyles();
  }
}
