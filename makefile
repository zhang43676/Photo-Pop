CHMOD = chmod 777 *.*

default:
	cd data_analysis; $(CHMOD)
	$(CHMOD) data_analysis
	cd display; $(CHMOD)
	$(CHMOD) display
	cd search; $(CHMOD)
	$(CHMOD) search
	cd security; $(CHMOD)
	$(CHMOD) security
	cd support; $(CHMOD)
	$(CHMOD) support
	cd uploading; $(CHMOD)
	$(CHMOD) uploading
	cd user_management; $(CHMOD)
	$(CHMOD) user_management
	cd user_help; $(CHMOD)
	$(CHMOD) user_help
	$(CHMOD)
	clear
	@echo "All Done! The site is ready to go :D"
	@ls -lrt

tar:
	tar -zcvf project.tgz *
