import { Injectable } from '@angular/core';
import { AbstractControl, AsyncValidator, ValidationErrors } from '@angular/forms';
import { Observable, of } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { catchError, delay, map } from 'rxjs/operators';
import { environment } from 'src/environments/environment'; 

@Injectable({
  providedIn: 'root'
})
export class UniqueNameValidatorService implements AsyncValidator {
  private baseUrl: string = environment.baseUrl;
  
  constructor(private http: HttpClient) { }

  validate(control: AbstractControl): Observable<ValidationErrors | null> {
    const name = control.value;
    const url = `${ this.baseUrl }templates/exists/${ name }`;
    return this.http.get<any[]>(url)
      .pipe(
        delay(1000),
        map( res => {
          return { nameExists: true }
        }),
        catchError(() => of(null))
      );
  }
}
