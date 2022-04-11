import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { GradientStyleService } from '../../services/gradient-style.service';
import { GradientDirectionService } from '../../services/gradient-direction.service';
import { ColorFormatService } from '../../services/color-format.service';
import { GradientStyle } from '../../shared/enums/gradient-style';
import { GradientDirection } from '../../shared/enums/gradient-direction';
import { ColorFormat } from '../../shared/enums/color-format';
import { ActivatedRoute } from '@angular/router';
import { Template } from '../../interfaces/template';
import { TemplateService } from '../../services/template.service';
import { UniqueNameValidatorService } from '../../validators/unique-name-validator.service';
import { faCheck, faClipboard } from '@fortawesome/free-solid-svg-icons';
import { ClipboardService } from 'ngx-clipboard';
import { CssGradientPipe } from '../../pipes/css-gradient.pipe';

@Component({
  selector: 'app-create',
  templateUrl: './create.component.html',
  styleUrls: ['./create.component.scss']
})
export class CreateComponent implements OnInit {
  defaultColorFrom = "#7500ff";
  colorFrom = this.defaultColorFrom;
  defaultColorTo = "#ff0099";
  colorTo = this.defaultColorTo;
  outputFormat = "Hex";

  styles!:any;
  directions!:any;
  colorFormats!:any;

  defaultStyle = 'Linear';
  defaultDirection = "Top";
  defaultColorFormat = "Hex";

  currentTemplate!: Template;

  createTemplateForm!: FormGroup;

  submittingForm = false;
  showTemplateCreatedMessage = false;

  faClipboard = faClipboard;
  faCheck = faCheck;
  
  copiedToClipboard = false;

  constructor(
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private templateService: TemplateService,
    private uniqueNameValidator: UniqueNameValidatorService,
    private clipboardApi: ClipboardService,
    private cssGradientPipe: CssGradientPipe
  ) {
  }

  ngOnInit(): void {
    this.styles = this.route.snapshot.data.styles; 
    this.directions = this.route.snapshot.data.directions; 
    this.colorFormats = this.route.snapshot.data.colorFormats; 

    this.createTemplateForm = this.fb.group({
      name: ['', [Validators.required, Validators.minLength(6), Validators.maxLength(50)], [this.uniqueNameValidator]],
      style: [this.defaultStyle, Validators.required],
      direction: [this.defaultDirection, Validators.required],
      colorFormat: [this.defaultColorFormat, Validators.required],
      colorFrom: [this.colorFrom, Validators.required],
      colorTo: [this.colorTo, Validators.required]
    });

    this.updateCss();

    this.createTemplateForm.valueChanges.subscribe(val => {
      this.updateCss();
    });
  }

  validName() {
    return this.createTemplateForm.controls['name'].errors && this.createTemplateForm.controls['name'].touched;
  }

  get nameErrorMessage(): string {
    let errorMessage: string = '';
    const errors = this.createTemplateForm.get('name')?.errors;
    if(errors?.required) {
      errorMessage = 'Template name is required.'; 
    } else if(errors?.nameExists) {
      errorMessage = 'Template name already exists.';
    } else if(errors?.minlength) {
      errorMessage = 'Template name must be at least 6 characters.'; 
    } else if(errors?.maxlength) {
      errorMessage = 'Maximum name length is 50 characters.'; 
    }
    return errorMessage;
  }

  createTemplate() {
    this.showTemplateCreatedMessage = false;
    this.submittingForm = true;
    if(this.createTemplateForm.invalid) {
      this.createTemplateForm.markAllAsTouched();
      this.submittingForm = false;
    } else {
      const { style, direction, colorFormat, name } = this.createTemplateForm.value;
      this.templateService.getTemplates(name)
        .subscribe(
          response => {
            this.templateService.create(
              name, 
              style, 
              direction, 
              colorFormat, 
              this.parseColor(colorFormat, this.colorFrom), 
              this.parseColor(colorFormat, this.colorTo), 
            ).subscribe(
              template => {
                this.showTemplateCreatedMessage = true;
                this.submittingForm = false;
              }
            );
          }
        );
    }    
  }

  updateCss() {
    this.currentTemplate = {
      style: this.createTemplateForm.controls['style'].value,
      direction: this.createTemplateForm.controls['direction'].value,
      color_from: this.parseColor(this.createTemplateForm.controls['colorFormat'].value, this.colorFrom),
      color_to: this.parseColor(this.createTemplateForm.controls['colorFormat'].value, this.colorTo),
    } as Template;
  }

  parseColor(format: string, hexColor: string) {
    if(format==ColorFormat.Rgb) {
      return `rgb(${this.hexToRgb(hexColor)})`;
    }
    return hexColor;
  }

  hexToRgb(hex:string) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    if(result){
        var r= parseInt(result[1], 16);
        var g= parseInt(result[2], 16);
        var b= parseInt(result[3], 16);
        return r+", "+g+", "+b;
    } 
    return null;
  }

  resetTemplateForm() {
    this.createTemplateForm.controls['style'].setValue(this.defaultStyle);
    this.createTemplateForm.controls['direction'].setValue(this.defaultDirection);
    this.createTemplateForm.controls['colorFormat'].setValue(this.defaultColorFormat);
    this.createTemplateForm.controls['name'].reset();
    this.colorFrom = this.defaultColorFrom;
    this.colorTo = this.defaultColorTo;
    this.showTemplateCreatedMessage = false;
    this.updateCss();
    return false;
  }

  copyTemplateCssToClipboard() {
    this.copiedToClipboard = true;
    this.clipboardApi.copyFromContent(this.cssGradientPipe.transform(this.currentTemplate) as string);
    setTimeout(() => {
        this.copiedToClipboard = false;
    }, 1000);
  }
}
