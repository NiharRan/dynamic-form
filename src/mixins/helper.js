export default {
  methods: {
    $copy: function(text) {
      console.log(text);
      const el = document.createElement("textarea");
      el.value = text;
      el.classList.add("hidden");
      document.body.appendChild(el);
      el.select();
      document.execCommand("copy");
      document.body.removeChild(el);
    },
  },
};
