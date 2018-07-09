import { FormulaModule } from './formula.module';

describe('FormulaModule', () => {
  let formulaModule: FormulaModule;

  beforeEach(() => {
    formulaModule = new FormulaModule();
  });

  it('should create an instance', () => {
    expect(formulaModule).toBeTruthy();
  });
});
