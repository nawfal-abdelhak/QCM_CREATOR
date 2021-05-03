export default () => {
  return {
    data() {
      return {
        errorMessage : "Veuillez réessayer ultérieurement!",
      }
    },
    methods: {
      swal: (title, type, timer) => {
        Vue.swal({
          position: "top-end",
          toast: true,
          title: title,
          type: type,
          showConfirmButton: false,
          timer: timer
        });
      }
    }
  }
}