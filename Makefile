clean:
	@for mydir in ".eggs" "build" "dist" "saxonpy.egg-info" "__pycache__" ".pytest_cache" "wheelhouse"; do \
		if test -d $$mydir; then \
			echo "----> removing dir $$mydir."; rm -Rf $$mydir; \
		else echo "Directory $$mydir doesn't exist." ; fi; done;
	@for f in "python_saxon/nodekind.c" "python_saxon/saxonc.cpp"; do \
		if test -e $$f; then \
			echo "----> removing file $$f."; rm $$f; \
		else echo "File $$f doesn't exist." ; fi; done

