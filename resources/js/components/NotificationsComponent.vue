<template>     
 <div>
  <b-dropdown  variant="link" toggle-class="text-decoration-none " style=" margin-top: -7px;" >
    <template v-slot:button-content>
       <span class="fa fa-bell"></span>  <span class="badge badge-light ">{{count}}</span>
    </template>
    
    <b-dropdown-item href="#">
      <div v-for="(unreadnotif,notifindex) in  unreadnotifs" :key="notifindex"> 
        <div v-if="!user"
          @click="sendnotif(unreadnotif.id)"
          style="background-color:lightgray"
        >{{unreadnotif.data['data']}}</div>
       
        <div v-if="user"
         @click="sendnotif(unreadnotif.id)"
          style="background-color:lightgray"
        >{{unreadnotif.data['data1']}}</div>
        </div>

        <div  v-for="(readnotif,notifindexx) in  readnotifs" :key="'hello'+notifindexx">
        <div v-if="!user"   >{{readnotif.data['data']}}</div>
        
        <div v-if="user">{{readnotif.data['data1']}}</div>

       </div>
    </b-dropdown-item>
    <!-- <b-dropdown-item href="#">Another action</b-dropdown-item>
    <b-dropdown-item href="#">Something else here...</b-dropdown-item> -->
  </b-dropdown>
</div>


  
 
</template>

<script>
export default {
  data() {
    return {
      user:null,
      readnotifs: [],
       unreadnotifs: [],
       count:0,
    };
  },
  methods: {
    // goTo(quizId) {
    //   this.$router.push({ name: "qcm", params: { quizId: quizId } });
    // }
     sendnotif(id) {
      console.log("ss");
        axios
          .post("markasread", {
            notif_id: id
          })
          .then(({ data }) => {
              console.log(data);
            
          })
          .catch(error => {
            console.error(error);
          })
          .then(() => {});
    }
  },
  created() {
    
 
    console.log(window.location.hostname);
    this.readnotifs=Laravel.readnotifs;
    this.unreadnotifs=Laravel.unreadnotifs;
    this.user=Laravel.user.is_admin;
    this.count=Laravel.count;

   
    
  },

   mounted() {
     
   var m=0;
   Echo.channel("NotifAnswer")
      .listen("NotifAnswer", ({ notifications,unreadnotifications }) => {
        console.log("read");
      console.log(notifications);
      console.log("unread");
      console.log(unreadnotifications);
      console.log(unreadnotifications.length);

        this.unreadnotifs=unreadnotifications;
        this.count=unreadnotifications.length;
        this.readnotifs=notifications;
        
         this.$forceUpdate();
       

      })





  },

  


  
    
};
</script>



<style scoped lang="scss">
    
</style>
    

