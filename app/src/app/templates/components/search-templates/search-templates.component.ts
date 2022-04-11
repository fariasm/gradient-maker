import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { TemplateService } from '../../services/template.service';
import { Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-search-templates',
  templateUrl: './search-templates.component.html',
  styleUrls: ['./search-templates.component.scss']
})
export class SearchTemplatesComponent implements OnInit {
  @Output() searchedTemplates = new EventEmitter<string>();

  searchForm: FormGroup = this.fb.group({
    name: ['']
  });

  constructor(
    private router: Router,
    private fb: FormBuilder,
    private templateService: TemplateService
  ) { }

  ngOnInit(): void {
  }

  search() {
    const name = this.searchForm.controls.name.value;
    this.templateService.getTemplates(name)
      .subscribe( templatesPagination => console.log(templatesPagination.data) );
  }
}
