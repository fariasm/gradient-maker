import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TemplatesRoutingModule } from './templates-routing.module';
import { ListComponent } from './pages/list/list.component';
import { TemplateCardComponent } from './components/template-card/template-card.component';
import { MaterialModule } from '../shared/material/material.module';


@NgModule({
  declarations: [  
    ListComponent,
    TemplateCardComponent
  ],
  imports: [
    CommonModule,
    TemplatesRoutingModule,
    MaterialModule
  ]
})
export class TemplatesModule { }
