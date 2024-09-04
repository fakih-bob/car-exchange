import 'package:carexchange/Components/MyTextField.dart';
import 'package:carexchange/Controller/NewPostController.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class NewPost extends GetView<Newpostcontroller> {
  final List<String> options = <String>[
    'Car',
    'Truck',
    'motorcycle',
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey,
      body: SingleChildScrollView(
        child: SafeArea(
          child: Center(
            child: Column(
              children: [
                const SizedBox(height: 25),
                const Text(
                  "Create your own post",
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 25),
                ),
                const SizedBox(height: 50),
                Obx(
                  () => DropdownButton<String>(
                    hint: Text('Select a category'),
                    value: controller.selectedOption.value.isEmpty
                        ? null
                        : controller.selectedOption.value,
                    items: options.map((option) {
                      return DropdownMenuItem<String>(
                        value: option,
                        child: Text(option),
                      );
                    }).toList(),
                    onChanged: (String? newValue) {
                      controller.selectedOption.value = newValue!;
                    },
                    isExpanded: true,
                  ),
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Name',
                  controller: controller.name,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Brand',
                  controller: controller.brand,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Color',
                  controller: controller.color,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Year',
                  controller: controller.year,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'price',
                  controller: controller.price,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Miles',
                  controller: controller.miles,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Description',
                  controller: controller.description,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'URL',
                  controller: controller.url,
                ),
                const SizedBox(height: 18),
                const Text(
                  "We are the car located!",
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 18),
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Country',
                  controller: controller.country,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'City',
                  controller: controller.city,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Street',
                  controller: controller.street,
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Car Address Description',
                  controller: controller.addressDescription,
                ),
                const SizedBox(height: 18),
                const Text(
                  "Your Car Pictures",
                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 18),
                ),
                const SizedBox(height: 18),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Picture URL 1',
                  controller: controller.url1,
                ),
                const SizedBox(height: 12),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Picture URL 2',
                  controller: controller.url2,
                ),
                const SizedBox(height: 12),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Picture URL 3',
                  controller: controller.url3,
                ),
                const SizedBox(height: 12),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Picture URL 4',
                  controller: controller.url4,
                ),
                const SizedBox(height: 12),
                MyTextfield(
                  obscureText: false,
                  hintText: 'Picture URL 5',
                  controller: controller.url5,
                ),
                const SizedBox(height: 18),
                ElevatedButton(
                  onPressed: () {
                    controller.postingCar();
                  },
                  style: ElevatedButton.styleFrom(
                    foregroundColor: Colors.white,
                    backgroundColor: Colors.black,
                    shadowColor: Colors.black,
                    elevation: 10,
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(8),
                    ),
                    padding: const EdgeInsets.symmetric(
                        horizontal: 100, vertical: 18),
                    textStyle: const TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  child: const Text('Post'),
                ),
                const SizedBox(height: 18),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
