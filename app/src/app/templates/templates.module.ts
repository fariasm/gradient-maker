import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TemplatesRoutingModule } from './templates-routing.module';
import { ListComponent } from './pages/list/list.component';
import { TemplateCardComponent } from './components/template-card/template-card.component';
import { CssGradientPipe } from './pipes/css-gradient.pipe';
import { ReactiveFormsModule } from '@angular/forms';
import { CreateComponent } from './pages/create/create.component';
import { ColorPickerModule } from 'ngx-color-picker';
import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { ClipboardModule } from 'ngx-clipboard';


@NgModule({
  declarations: [  
    ListComponent,
    TemplateCardComponent,
    CssGradientPipe,
    CreateComponent,
  ],
  imports: [
    CommonModule,
    TemplatesRoutingModule,
    ReactiveFormsModule,
    ColorPickerModule,
    FontAwesomeModule,
    ClipboardModule
  ],
  providers: [
    CssGradientPipe
  ]
})
export class TemplatesModule { }
