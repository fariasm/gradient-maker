import { Component, OnInit } from '@angular/core';
import { Template } from '../../interfaces/template';
import { TemplateService } from '../../services/template.service';

@Component({
  selector: 'app-templates-list',
  templateUrl: './templates-list.component.html',
  styleUrls: ['./templates-list.component.scss']
})
export class TemplatesListComponent implements OnInit {

  templates!: Template[];
  
  constructor( private templateService: TemplateService ) { }

  ngOnInit(): void {

    this.templateService.getTemplates()
      .subscribe( templatesPagination => this.templates = templatesPagination.data );

  }

}
