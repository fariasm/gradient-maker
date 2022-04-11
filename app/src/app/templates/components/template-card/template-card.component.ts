import { Component, Input, OnInit } from '@angular/core';
import { Template } from '../../interfaces/template';
import { GradientStyle } from '../../shared/enums/gradient-style';
import { GradientDirection } from '../../shared/enums/gradient-direction';

@Component({
  selector: 'app-template-card',
  templateUrl: './template-card.component.html',
  styleUrls: ['./template-card.component.scss']
})
export class TemplateCardComponent implements OnInit {
  @Input() template!: Template;

  constructor() { }

  ngOnInit(): void {
    console.log(this.template);
  }

}
