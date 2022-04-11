import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { GradientDirection } from '../shared/enums/gradient-direction';

@Injectable({
  providedIn: 'root'
})
export class GradientDirectionService {
  private baseUrl: string = environment.baseUrl;

  constructor( private http: HttpClient ) { }

  getDirections(): Observable<any[]> {
    return this.http.get<any[]>(`${ this.baseUrl }directions`);
  }
}
