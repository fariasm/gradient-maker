import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ColorFormat } from '../shared/enums/color-format';

@Injectable({
  providedIn: 'root'
})
export class ColorFormatService {
  private baseUrl: string = environment.baseUrl;

  constructor( private http: HttpClient ) { }

  getFormats(): Observable<any[]> {
    return this.http.get<any[]>(`${ this.baseUrl }color-formats`);
  }
}
