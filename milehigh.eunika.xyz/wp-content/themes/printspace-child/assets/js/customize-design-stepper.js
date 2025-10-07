jQuery(document).ready(function($) {
  let currentStep = 0;
  const steps = $('.step');
  const panels = $('.step-panel');

  function showStep(index) {
    panels.removeClass('active').eq(index).addClass('active');
    steps.removeClass('active').eq(index).addClass('active');
    $('#prevBtn').prop('disabled', index === 0);
    $('#nextBtn').text(index === steps.length - 1 ? 'Finish' : 'Continue');
  }

  $('#nextBtn').on('click', function() {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    } else {
      alert('Stepper complete!');
    }
  });

  $('#prevBtn').on('click', function() {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  });

  showStep(currentStep);
});
