jQuery(document).ready(function ($) {
  $(document).on('click touchstart', '.social-share a', function(e) {
    e.preventDefault();
    const postUrl = encodeURIComponent($(this).attr('data-post-url'));
    const postTitle = encodeURIComponent($(this).attr('data-post-title'));
    const shareOption = $(this).attr('data-share-option');
    const shareOptionUrls = {
      facebook: `https://www.facebook.com/sharer.php?u=${postUrl}`,
      linkedin: `https://www.linkedin.com/shareArticle?mini=true&url=${postUrl}`,
      x: `https://twitter.com/intent/tweet?text=${postTitle}%20${postUrl}`,
      email: `mailto:?subject=${postTitle}&body=Link:%20${postUrl}`,
    }
    if (shareOption === 'copy' && navigator.clipboard) {
      navigator.clipboard.writeText($(this).attr('data-post-url'))
      .then(() => {
        $('.custom-toast-wrapper').show().delay(2500).fadeOut();
      })
      .catch((error) => {
        $('.custom-toast-wrapper .toast-header span').text("Something went wrong. Link did NOT copy!");
        $('.custom-toast-wrapper').show().delay(2500).fadeOut();
      });
    } else {
      window.open(shareOptionUrls[shareOption]);
    }
  });
});