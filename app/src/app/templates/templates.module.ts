import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TemplatesRoutingModule } from './templates-routing.module';
import { ListComponent } from './pages/list/list.component';
import { TemplateCardComponent } from './components/template-card/template-card.component';
import { CssGradientPipe } from './pipes/css-gradient.pipe';
import { SearchTemplatesComponent } from './components/search-templates/search-templates.component';
import { ReactiveFormsModule } from '@angular/forms';
import { TemplatesListComponent } from './components/templates-list/templates-list.component';
import { CreateComponent } from './pages/create/create.component';


@NgModule({
  declarations: [  
    ListComponent,
    TemplateCardComponent,
    CssGradientPipe,
    SearchTemplatesComponent,
    TemplatesListComponent,
    CreateComponent,
  ],
  imports: [
    CommonModule,
    TemplatesRoutingModule,
    ReactiveFormsModule
  ]
})
export class TemplatesModule { }
