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
        <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>
        <v-card>
          <v-card-title>
            <span class="headline" >{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm6 md6>
                  <v-text-field v-model="editedItem.tenant_name" label="أســم المستأجر"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6>
                  <v-text-field v-model="editedItem.tenant_phone" label="رقــم الهاتـف"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                       <v-select       
                        :items="cars_types"      
                        v-model="editedItem.car_type_id" 
                         item-text="car_type"
                        item-value="id"
                        label="نوع المركبه"
                     
                        required >  
                    </v-select>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <input type="datetime-local" id="start" name="trip-start"
                value="2018-07-22" label="ss"
                min="2018-01-01" v-model="editedItem.trip_date" max="2018-12-31"
                style="    border: 1px solid #1f3436;
              padding-top: 30px;background-color:#eee" >

                
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
   </v-container>
</template>

<script>
  export default {
    data: () => ({
      tickets: [],
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
      
        { text: 'Actions', value: 'name', sortable: false }
      ],
      desserts: [],
      cars_types: [],
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

    created () {
      this.initialize()
      this.loadTickets()
      this.cars_type()
    },

    methods: {
      initialize () {
        this.desserts = this.tickets
      },

      editItem (item) {
        this.editedIndex = this.tickets.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
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
          Object.assign(this.tickets[this.editedIndex], this.editedItem)
        } else {

          //save Item

          axios.post('api/tickets', {
          tenant_name:this.editedItem.tenant_name,
          tenant_phone:this.editedItem.tenant_phone,
          car_type_id:this.editedItem.car_type_id,
          trip_date:this.editedItem.trip_date,
					
				}).then(() => {
					this.dialog = false
          Fire.$emit('AfterCreate');
          toast({
            type: 'success',
            title: 'Signed in successfully'
          })
				}).catch(() => {})
          this.loadTickets()
          this.tickets.push(this.editedItem)
        }
        this.close()
      },
      	loadTickets() {
				this.$validator.localize('en', this.dictionary)
				axios.get('api/tickets').then(response => (this.tickets= response.data))
      },
      cars_type(){
        this.$validator.localize('en', this.dictionary)
				axios.get('api/carstype').then(response => (this.cars_types= response.data))
      }

    }
  }
</script>