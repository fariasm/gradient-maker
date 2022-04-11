import { Injectable } from '@angular/core';
import {
  Router, Resolve,
  RouterStateSnapshot,
  ActivatedRouteSnapshot
} from '@angular/router';
import { Observable, of } from 'rxjs';
import { GradientDirectionService } from '../services/gradient-direction.service';

@Injectable({
  providedIn: 'root'
})
export class GradientDirectionResolver implements Resolve<any> {
  constructor(private gradientDirection: GradientDirectionService) {}

  resolve(route: ActivatedRouteSnapshot): Observable<any> {
    return this.gradientDirection.getDirections();
  }
}
