import 'package:carexchange/Components/MyTextField.dart';
import 'package:carexchange/Controller/UpdateController.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class UpdatePost extends StatelessWidget {
  final List<String> options = <String>[
    'Car',
    'Truck',
    'MotorCycle',
  ];
  final int postId;
  UpdatePost({Key? key, required this.postId}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final Updatecontroller updatecontroller = Get.find<Updatecontroller>();
    return Scaffold(
      backgroundColor: Colors.grey,
      body: SingleChildScrollView(
        child: SafeArea(
          child: Center(
            child: Column(
              children: [
                const SizedBox(height: 25),
                Text(
                  "Edit your post",
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 25),
                ),
                const SizedBox(height: 50),
                Obx(
                  () => DropdownButton<String>(
                    hint: const Text('Select a category'),
                    value:
                        options.contains(updatecontroller.selectedOption.value)
                            ? updatecontroller.selectedOption.value
                            : null,
                    items: options.map((option) {
                      return DropdownMenuItem<String>(
                        value: option,
                        child: Text(option),
                      );
                    }).toList(),
                    onChanged: (String? newValue) {
                      updatecontroller.selectedOption.value = newValue ?? '';
                    },
                    isExpanded: true,
                  ),
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Name',
                  controller: updatecontroller.name,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Brand',
                  controller: updatecontroller.brand,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Color',
                  controller: updatecontroller.color,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Year',
                  controller: updatecontroller.year,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Price',
                  controller: updatecontroller.price,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Miles',
                  controller: updatecontroller.miles,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Description',
                  controller: updatecontroller.description,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'URL',
                  controller: updatecontroller.url,
                ),
                Text(
                  "Car Address",
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 25),
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Country',
                  controller: updatecontroller.country,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'city',
                  controller: updatecontroller.city,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Street',
                  controller: updatecontroller.street,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Address Drescription',
                  controller: updatecontroller.addressDescription,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Description',
                  controller: updatecontroller.description,
                ),
                Text(
                  "Car Pictures",
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 25),
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Url1',
                  controller: updatecontroller.url1,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Url2',
                  controller: updatecontroller.url2,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Url3',
                  controller: updatecontroller.url3,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Url4',
                  controller: updatecontroller.url4,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Url5',
                  controller: updatecontroller.url5,
                ),
                const SizedBox(height: 18),
                ElevatedButton(
                  onPressed: () {
                    updatecontroller.updatePost(postId);
                    Get.offNamed(AppRoute.posts);
                  },
                  child: const Text('Update Post'),
                ),
                const SizedBox(height: 18),
                ElevatedButton(
                  onPressed: () async {
                    final post = await updatecontroller.getPostById(postId);
                    if (post != null) {
                      updatecontroller.updateFormFields(post);
                    } else {
                      Get.snackbar('Error', 'Failed to fetch post data');
                    }
                  },
                  child: const Text('get Post data'),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
