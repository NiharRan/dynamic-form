export default function useSlugable(form) {
  function generateSlug() {
    const slug = form.title
      .toLowerCase()
      .replace(/ /g, "-")
      .replace(/[^\w-]+/g, "");
    form.slug = slug;
  }

  return {
    generateSlug,
  };
}
