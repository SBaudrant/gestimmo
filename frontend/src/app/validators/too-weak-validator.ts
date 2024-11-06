import { AbstractControl, ValidatorFn } from '@angular/forms';

export const tooWeakValidator: ValidatorFn = (passwordControl: AbstractControl) => {
  const password = passwordControl.value;

  if (!password) {
    return null;
  }

  const validated = [
    /[a-z]/,
    /[A-Z]/,
    /[0-9]/,
    /[.,;:!?/@#()-]/,
  ]
    .map(regex => regex.test(password))
    .filter(valid => valid)
    .length
  ;

  return validated >= 3
    ? null
    : { tooWeak: true }
  ;
};
