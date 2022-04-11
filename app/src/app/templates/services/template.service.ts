import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { TemplatesPagination } from '../interfaces/templates-pagination';
import { Template } from '../interfaces/template';

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

  create(name: string, style:string, direction:string, colorFormat: string, colorFrom:string, colorTo:string) {
    const url = `${ this.baseUrl }templates`;
    const body = { 
      name: name,
      style: style,
      direction: direction,
      color_format: colorFormat,
      color_from: colorFrom,
      color_to: colorTo
    };
    return this.http.post<Template>(url, body);
  }
}
