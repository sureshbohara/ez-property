export const formatPrice = (price) => {
 return new Intl.NumberFormat('en-NP', {
  style: 'currency',
  currency: 'NPR'
}).format(price);
};

export const formatDate = (date) => {
 return new Date(date).toLocaleDateString('en-US', {
  year: 'numeric',
  month: 'long',
  day: 'numeric'
});
};
