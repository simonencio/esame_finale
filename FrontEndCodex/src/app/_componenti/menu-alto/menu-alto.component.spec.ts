import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MenuAltoComponent } from './menu-alto.component';

describe('MenuAltoComponent', () => {
  let component: MenuAltoComponent;
  let fixture: ComponentFixture<MenuAltoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [MenuAltoComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MenuAltoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
