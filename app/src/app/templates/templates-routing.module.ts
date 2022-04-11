import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CreateComponent } from './pages/create/create.component';
import { ListComponent } from './pages/list/list.component';
import { GradientStyleResolver } from './resolvers/gradient-style.resolver';
import { GradientDirectionResolver } from './resolvers/gradient-direction.resolver';
import { ColorFormatResolver } from './resolvers/color-format.resolver';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'templates'
  },
  {
    path: 'templates',
    component: ListComponent
  },
  {
    path: 'create-template',
    component: CreateComponent,
    resolve: {
      styles: GradientStyleResolver,
      directions: GradientDirectionResolver,
      colorFormats: ColorFormatResolver
    }
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TemplatesRoutingModule { }
