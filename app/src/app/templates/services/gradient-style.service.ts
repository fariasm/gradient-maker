import { Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { GradientStyle } from '../shared/enums/gradient-style';

@Injectable({
  providedIn: 'root'
})
export class GradientStyleService {
  private baseUrl: string = environment.baseUrl;

  constructor( private http: HttpClient ) { }

  getStyles(): Observable<any[]> {
    return this.http.get<any[]>(`${ this.baseUrl }styles`);
  }
}
