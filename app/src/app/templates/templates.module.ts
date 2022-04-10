import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TemplatesRoutingModule } from './templates-routing.module';
import { MainComponent } from './pages/main/main.component';
import { TemplatesListComponent } from './components/templates-list/templates-list.component';


@NgModule({
  declarations: [
    MainComponent,
    TemplatesListComponent
  ],
  imports: [
    CommonModule,
    TemplatesRoutingModule
  ]
})
export class TemplatesModule { }
