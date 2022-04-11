import { Pipe, PipeTransform } from '@angular/core';
import { Template } from '../interfaces/template';
import { GradientDirection } from '../shared/enums/gradient-direction';
import { GradientStyle } from '../shared/enums/gradient-style';

@Pipe({
  name: 'cssGradient'
})
export class CssGradientPipe implements PipeTransform {

  transform(value: Template, ...args: unknown[]): unknown {
    if(value) {
      const colorFrom = value.color_from;
      const colorTo = value.color_to;
      const direction = GradientDirection[value.direction as keyof typeof GradientDirection];
      if(value.style.toLowerCase()==GradientStyle.Linear.toLowerCase()) {
        return `background: linear-gradient(to ${direction}, ${colorFrom}, ${colorTo});`;
      } else {
        return `background: -webkit-radial-gradient(${direction}, ${colorFrom}, ${colorTo});`;
      }      
    }
    return '';
  }

}

