function toggleFGR(expand) {
    document.getElementById('ratingBadge').classList.toggle('d-none', expand);
    document.getElementById('fullReviewCard').classList.toggle('d-none', !expand);
  }
  