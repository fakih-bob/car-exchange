import 'package:carexchange/Core/networks/DioClient-auth.dart';
import 'package:carexchange/models/User.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

class UserController extends GetxController {
  var user = User(name: '', email: '', phoneNumber: '').obs; // Observable User

  late DioClient1 dioClient1;
  late SharedPreferences prefs;

  @override
  void onInit() {
    super.onInit();
    _initUserController();
  }

  // Initialization logic for SharedPreferences and DioClient
  Future<void> _initUserController() async {
    try {
      prefs = await SharedPreferences.getInstance();
      dioClient1 = DioClient1(prefs);
      await getUser(); // Fetch user data
    } catch (e) {
      print("Error during initialization: $e");
    }
  }

  // Fetch user data from the API
  Future<void> getUser() async {
    try {
      var response = await dioClient1.getInstance().get('/user');
      if (response.statusCode == 200) {
        var requestData = response.data['data']; // Extract 'data' field
        user.value = User.fromJson(requestData); // Update the observable
      } else {
        print("Failed to fetch user data. Status code: ${response.statusCode}");
      }
    } catch (e) {
      print("Exception during API call: $e");
    }
  }
}
