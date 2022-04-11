import { Component, Input, OnInit } from '@angular/core';
import { Template } from '../../interfaces/template';
import { ClipboardService } from 'ngx-clipboard';
import { CssGradientPipe } from '../../pipes/css-gradient.pipe';

@Component({
  selector: 'app-template-card',
  templateUrl: './template-card.component.html',
  styleUrls: ['./template-card.component.scss']
})
export class TemplateCardComponent implements OnInit {
  @Input() template!: Template;

  defaultCopyText = "Copy CSS to clipboard";
  copyText = this.defaultCopyText;

  constructor(
    private clipboardApi: ClipboardService,
    private cssGradientPipe: CssGradientPipe
    ) { }

  ngOnInit(): void {
  }

  copyTemplateCssToClipboard() {
    this.copyText = "Copied!";
    this.clipboardApi.copyFromContent(this.cssGradientPipe.transform(this.template) as string);
    setTimeout(() => {
      this.copyText =this.defaultCopyText;
  }, 1000);
  }

}
