<template>
 <v-container>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>التذاكـــر</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" persistent  max-width="600px">
       <!-- <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>-->
        <v-card>
          <v-card-title>
            <span class="headline" >{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm6 md6>
                  <v-text-field v-model="editedItem.tenant_name" disabled label="أســم المستأجر"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6>
                  <v-text-field v-model="editedItem.tenant_phone" disabled label="رقــم الهاتـف"></v-text-field>
                </v-flex>

                

                
                <v-flex xs12 sm6 md4>
                       <v-select       
                        :items="cars_types"      
                        v-model="editedItem.car_type_id" 
                         item-text="car_type"
                        item-value="id"
                        label="نوع المركبه"
                     disabled
                        required >  
                    </v-select>
                </v-flex>
                <v-flex xs12 sm6 md4>

                </v-flex>


                   <v-flex xs12 sm6 md4>
                  <input type="text" id="start" name="trip-start"
                 value="2018-07-22" 
                 v-model="editedItem.trip_date" disabled>

                
                </v-flex>

                <v-flex xs12 sm6 md12>
                       <v-select       
                        :items="car_type_order"      
                         v-model="car_type_order_item.id" 
                      
                          item-text="ptx"                      
                         item-value="id"
                         label="اختار السياره المناسبه للطلب"

                        required >  
                    </v-select>
                </v-flex>


                  <v-flex xs12 sm6 md12>
                       <v-select       
                        :items="drivers"      
                        v-model="driver_item.id" 
                         item-text="name"
                        item-value="id"
                        label="اسم سائق المركبه"
                     
                        required >  
                    </v-select>
                </v-flex>


                
             
               
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="tickets"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.tenant_name }}</td>
        <td class="text-xs-right">{{ props.item.tenant_phone}}</td>
        <td class="text-xs-right">{{ props.item.car_type}}</td>
        <td class="text-xs-right">{{ props.item.trip_date }}</td>
        <td class="text-xs-right">{{ props.item.car_num }}</td>
         <td class="text-xs-right">{{ props.item.phone }}</td>
           <td class="text-xs-right">{{ props.item.name }}</td>
        
        <td class="justify-center layout px-0">
          <v-icon
            small
            class="mr-2"
            @click="editItem(props.item)"
          >
            edit
          </v-icon>
          <v-icon
            small
            @click="deleteItem(props.item)"
          >
            delete
          </v-icon>
        </td>
      </template>
      <template slot="no-data">
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </div>






  <v-layout row>
  

    


      <v-btn  @click="booked"  dark color="success" style="float:left">
          <p> الحجوزات</p>
      </v-btn>

       <v-btn  @click="unbooked"  dark color="error" style="float:left">
          <p> الطلبات</p>
      </v-btn>

    

 

 
</v-layout>

   </v-container>



</template>

<script>
  export default {
    data: () => ({
      tickets: [],
     av:'',
      editedItem:'',
      selectedItems: [],
                
      dialog: false,
      headers: [
        {
          text: 'اسم المستأجر',
          align: 'left',
          sortable: false,
          value: 'name'
        },
        { text: 'هاتف المستأجر', value: 'tenant_phone' },
        { text: 'نوع المركبه', value: 'fat' },
        { text: 'تاريخ الرحله', value: 'carbs' },
        { text: 'رقم المركبه', value: 'car_num' },
        { text:'رقم السائق', value: 'phone' },
         { text:'اسم السائق', value: 'name' },
      
        { text: 'Actions', value: 'name', sortable: false }
      ],
      desserts: [],
      cars_types: [],
      drivers:[],
     
      editedIndex: -1,
        car_type_order:{
        car_num:this.car_type_order,
      },

       car_type_order_item:{
        car_num:'',
      },

      driver_item:{
        id:'',
      },

    

       editedIndex: -1,
   


      editedItem: {
        name: '',
        tenant_phone: 0,
        fat: 0,
        carbs: 0,
       
      },
      defaultItem: {
        name: '',
       tenant_phone: 0,
        fat: 0,
        carbs: 0,
       
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'أضافه' : 'Edit Item'
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

  

    methods: {
      initialize () {
        this.desserts = this.tickets
      },



      

      editItem (item) {
         
       this.editedIndex = this.tickets.indexOf(item)
       this.editedItem = Object.assign({}, item)
       this.car_type_order_item = Object.assign({},this.car_type_order)    
       this.dialog = true
        
     
         this.driverss();
       this.car_orders(item.car_type_id);
      },
      
            car_orders(car_type_id){
            axios.get('api/cars_orders?car_type='+car_type_id).then(response => (this.car_type_order= response.data))
            },


      deleteItem (item) {
        const index = this.tickets.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.tickets.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
	  
        if (this.editedIndex > -1) {
          //edite
 
          console.log('Editing the Data');
          axios.put('api/tickets/'+this.editedItem.id,{ 
          car_id:this.car_type_order_item.id,
           driver_id:this.driver_item.id,
       })
         

           this.loadTickets()
            this.cars_type()

         console.log('Editing the Data');
          Object.assign(this.tickets[this.editedIndex], this.editedItem)
        } else {
         //save
    
          this.tickets.push(this.editedItem)
        }
        this.close()
      },

      	loadTickets() {
				this.$validator.localize('en', this.dictionary)
				axios.get('api/tickets/0').then(response => (this.tickets= response.data))
      },

        booked() {
                    this.$validator.localize('en', this.dictionary)
                    axios.get('api/tickets_booked').then(response => (this.tickets = response.data))
             },

              unbooked() {
                    this.$validator.localize('en', this.dictionary)
                    axios.get('api/tickets/0').then(response => (this.tickets = response.data))
             },

      cars_type(){
        this.$validator.localize('en', this.dictionary)
				axios.get('api/carstype').then(response => (this.cars_types= response.data))
      },

       driverss(){
         console.log('drivers');
        this.$validator.localize('en', this.dictionary)
				axios.get('api/drivers').then(response => (this.drivers= response.data))
      },
      
         

             

    },

      created () {
        this.loadTickets();
 
    
   
      this.cars_type()
    },
  }
</script>