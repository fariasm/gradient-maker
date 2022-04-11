import { Component, OnInit } from '@angular/core';
import { TemplateService } from '../../services/template.service';
import { TemplatesPagination } from '../../interfaces/templates-pagination';
import { Template } from '../../interfaces/template';

@Component({
  selector: 'app-list',
  templateUrl: './list.component.html',
  styleUrls: ['./list.component.scss']
})
export class ListComponent implements OnInit {
  templates!: Template[];
  
  constructor( private templateService: TemplateService ) { }

  ngOnInit(): void {

    this.templateService.getTemplates()
      .subscribe( templatesPagination => this.templates = templatesPagination.data );

  }

}
