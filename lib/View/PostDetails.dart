import 'dart:ui';
import 'package:carexchange/models/Post.dart';
import 'package:flutter/material.dart';

class PostDetails extends StatelessWidget {
  final Post post;

  const PostDetails({super.key, required this.post});

  @override
  Widget build(BuildContext context) {
    // Get the screen height for dynamic adjustment
    double screenHeight = MediaQuery.of(context).size.height;

    return SafeArea(
      child: Scaffold(
        body: Stack(
          children: [
            Stack(
              children: [
                // Dynamically adjust the height of the image
                SizedBox(
                  height: screenHeight *
                      0.35, // Adjust this value to make the image height proportional to screen
                  width: double.infinity,
                  child: PageView.builder(
                    itemCount: post.pictures.length,
                    itemBuilder: (context, index) {
                      return SizedBox(
                        width: double.infinity,
                        child: Image.network(
                          post.pictures[index].url,
                          fit: BoxFit.cover,
                        ),
                      );
                    },
                  ),
                ),
              ],
            ),
            buildButton(context),
            buildScroll(),
          ],
        ),
      ),
    );
  }

  Widget buildButton(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(20.0),
      child: InkWell(
        onTap: () {
          Navigator.pop(context);
        },
        child: Container(
          clipBehavior: Clip.hardEdge,
          height: 55,
          width: 55,
          decoration: BoxDecoration(borderRadius: BorderRadius.circular(25)),
          child: BackdropFilter(
            filter: ImageFilter.blur(
              sigmaX: 10,
              sigmaY: 10,
            ),
            child: Container(
              height: 55,
              width: 55,
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(25),
              ),
              child: const Icon(
                Icons.arrow_back_ios,
                size: 20,
                color: Colors.white,
              ),
            ),
          ),
        ),
      ),
    );
  }

  Widget buildScroll() {
    return DraggableScrollableSheet(
      initialChildSize: 0.695,
      maxChildSize: 1.0,
      minChildSize: 0.695,
      builder: (context, scrollController) {
        return Container(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          clipBehavior: Clip.hardEdge,
          decoration: const BoxDecoration(
            color: Colors.grey,
            borderRadius: BorderRadius.only(
              topLeft: Radius.circular(20),
              topRight: Radius.circular(20),
            ),
          ),
          child: SingleChildScrollView(
            controller: scrollController,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Padding(
                  padding: const EdgeInsets.only(top: 10, bottom: 25),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Container(
                        height: 5,
                        width: 35,
                        color: Colors.black,
                      ),
                    ],
                  ),
                ),
                Text(
                  post.car.name,
                  style: const TextStyle(
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 10),
                Text(
                  post.car.category,
                  style: const TextStyle(
                    fontSize: 16,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 10),
                Text(
                  post.car.price != null
                      ? '\$${post.car.price}'
                      : 'Call for price',
                  style: const TextStyle(
                    color: Colors.black,
                    fontWeight: FontWeight.bold,
                    fontSize: 18,
                  ),
                ),
                const SizedBox(height: 20),
                buildCarInfo(),
                const SizedBox(height: 20),
                buildAddressInfo(),
                const SizedBox(height: 20),
                buildUserInfo(),
              ],
            ),
          ),
        );
      },
    );
  }

  Widget buildCarInfo() {
    return Column(
      children: [
        buildInfoRow(Icons.speed, 'Mileage: ${post.car.miles}'),
        const SizedBox(height: 5),
        buildInfoRow(Icons.branding_watermark, 'Brand: ${post.car.brand}'),
        const SizedBox(height: 5),
        buildInfoRow(Icons.calendar_today, 'Year: ${post.car.year}'),
        const SizedBox(height: 5),
        buildInfoRow(Icons.color_lens, 'Color: ${post.car.color}'),
        const SizedBox(height: 5),
        buildInfoRow(
            Icons.settings, 'Car Description: ${post.car.description}'),
      ],
    );
  }

  Widget buildAddressInfo() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Address:',
          style: TextStyle(
            fontSize: 24,
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
        const SizedBox(height: 10),
        buildInfoRow(Icons.location_city, 'City: ${post.address.city}'),
        const SizedBox(height: 5),
        buildInfoRow(Icons.streetview, 'Street: ${post.address.street}'),
        const SizedBox(height: 5),
        buildInfoRow(
            Icons.markunread_mailbox, 'Country: ${post.address.country}'),
        const SizedBox(height: 5),
        buildInfoRow(
            Icons.public, 'Address Description: ${post.address.description}'),
      ],
    );
  }

  Widget buildUserInfo() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Seller Information:',
          style: TextStyle(
            fontSize: 24,
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
        const SizedBox(height: 10),
        buildInfoRow(Icons.person, 'Name: ${post.userInfo.name}'),
        const SizedBox(height: 5),
        buildInfoRow(Icons.email, 'Email: ${post.userInfo.email}'),
        const SizedBox(height: 5),
        buildInfoRow(Icons.phone, 'Phone: ${post.userInfo.phoneNumber}'),
      ],
    );
  }

  Widget buildInfoRow(IconData icon, String text) {
    return Row(
      crossAxisAlignment:
          CrossAxisAlignment.start, // Align text and icon to top
      children: [
        Icon(icon, color: Colors.white),
        const SizedBox(width: 10),
        Expanded(
          child: Text(
            text,
            style: const TextStyle(
              fontSize: 16,
              color: Colors.white,
            ),
            softWrap: true, // Enable text wrapping
            overflow:
                TextOverflow.visible, // Allow text to overflow to the next line
          ),
        ),
      ],
    );
  }
}
