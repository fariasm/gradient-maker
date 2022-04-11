import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { TemplatesPagination } from '../interfaces/templates-pagination';

@Injectable({
  providedIn: 'root'
})
export class TemplateService {
  private baseUrl: string = environment.baseUrl;

  constructor( private http: HttpClient ) { }

  getTemplates(name?: string): Observable<TemplatesPagination> {
    let queryParameters = '';
    if(name) {
      queryParameters = `name=${ name }`;
    }
    return this.http.get<TemplatesPagination>(`${ this.baseUrl }templates?${ queryParameters }`);
  }
}
