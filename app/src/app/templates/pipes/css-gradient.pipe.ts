import { Pipe, PipeTransform } from '@angular/core';
import { Template } from '../interfaces/template';
import { GradientDirection } from '../shared/enums/gradient-direction';
import { GradientStyle } from '../shared/enums/gradient-style';

@Pipe({
  name: 'cssGradient'
})
export class CssGradientPipe implements PipeTransform {

  transform(value: Template, ...args: unknown[]): unknown {
    const colorFrom = value.color_from;
    const colorTo = value.color_to;
    const direction = GradientDirection[value.direction as keyof typeof GradientDirection];
    const style = GradientStyle[value.style as keyof typeof GradientStyle];
    return `background-image: ${style}-gradient(to ${direction}, ${colorFrom}, ${colorTo});`;
  }

}
