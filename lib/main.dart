import 'package:carexchange/Controller/LoginController.dart';
import 'package:carexchange/Controller/NewPostController.dart';
import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Routes/AppPage.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_core/src/get_main.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const MyApp());
  Get.lazyPut(() => LoginController());
  Get.lazyPut(() => PostController());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      title: 'Flutter Demo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      initialRoute: AppRoute.posts,
      getPages: AppPage.pages,
      debugShowCheckedModeBanner: false,
    );
  }
}
